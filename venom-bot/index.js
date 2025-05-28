const venom = require('venom-bot');
const express = require('express');
const fs = require('fs');
const path = require('path');
const axios = require('axios');
const app = express();
app.use(express.json());

let clientVenom = null;

// Configuración: máximo de números por solicitud
const MAX_NUMEROS = 10;

// Validación de número simple
const isValidNumber = num => /^\d{10,13}$/.test(num);

venom
  .create({
    session: 'session-name',
    multidevice: true,
    headless: true,
    browserArgs: [
      '--no-sandbox',
      '--disable-setuid-sandbox',
      '--disable-dev-shm-usage',
      '--disable-accelerated-2d-canvas',
      '--no-first-run',
      '--no-zygote',
      '--single-process',
      '--disable-gpu'
    ],
    executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
  })
  .then((client) => {
    clientVenom = client;
    console.log('Sesión creada con éxito');

    client.onStateChange((state) => {
      console.log('Estado de sesión:', state);
      if (state === 'CONFLICT' || state === 'UNPAIRED' || state === 'UNLAUNCHED') {
        clientVenom.useHere();
        console.log('Intentando recuperar la sesión de Venom...');
      }
    });
  })
  .catch((error) => {
    console.log('Error creando la sesión:', error);
  });

const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
const DELAY_MS = 7000;

// Descarga una imagen remota a un archivo temporal
async function downloadImage(url, outputPath) {
  const writer = fs.createWriteStream(outputPath);
  const response = await axios({
    url,
    method: 'GET',
    responseType: 'stream'
  });
  response.data.pipe(writer);
  return new Promise((resolve, reject) => {
    writer.on('finish', resolve);
    writer.on('error', reject);
  });
}

let enviando = false;

app.post('/send-message', async (req, res) => {
  if (enviando) {
    return res.status(429).json({ success: false, error: 'Ya hay un envío en proceso. Intenta más tarde.' });
  }
  enviando = true;

  const timeout = setTimeout(() => {
    enviando = false;
    res.status(504).json({ success: false, error: 'Tiempo de espera agotado para el envío de mensajes.' });
  }, 120000);

  try {
    // Ajuste para la nueva BD: solo acepta array "clientes" con los campos esperados
    let clientes = req.body.clientes;
    if (!clientes && req.body.numero && req.body.mensaje) {
      // Compatibilidad: si viene un solo objeto, lo convierte en array
      clientes = [req.body];
    }

    console.log('Cuerpo recibido:', JSON.stringify(clientes, null, 2));

    if (!Array.isArray(clientes) || clientes.length === 0) {
      clearTimeout(timeout);
      enviando = false;
      return res.status(400).json({ success: false, error: 'Debes enviar un array "clientes" o un objeto con los datos.' });
    }

    if (clientes.length > MAX_NUMEROS) {
      clearTimeout(timeout);
      enviando = false;
      return res.status(400).json({ success: false, error: `No se pueden enviar más de ${MAX_NUMEROS} mensajes por solicitud.` });
    }

    const resultados = [];

    for (const cliente of clientes) {
      // Ajuste: los campos deben coincidir con la estructura de la BD y el backend Laravel
      // cliente: { numero, mensaje, titulo, imagen }
      const { numero, mensaje, titulo, imagen } = cliente;

      if (!numero || !isValidNumber(numero) || !mensaje) {
        resultados.push({
          numero: numero || null,
          status: 'error',
          error: 'Número o mensaje inválido.'
        });
        continue;
      }

      try {
        let mensajeAEnviar = mensaje;
        if (titulo) {
          mensajeAEnviar = `*${titulo}*\n${mensaje}`;
        }

        console.log(`Enviando a: ${numero}, Imagen: ${imagen ? imagen : 'No hay imagen'}, Título: ${titulo ? titulo : 'No hay título'}`);

        if (imagen) {
          // Descargar imagen y enviar como archivo local
          const tempPath = path.join(__dirname, 'temp_img_' + Date.now() + '.jpg');
          await downloadImage(imagen, tempPath);
          await clientVenom.sendImage(`${numero}@c.us`, tempPath, 'imagen.jpg', mensajeAEnviar);
          fs.unlinkSync(tempPath); // Borra el archivo temporal
          resultados.push({ numero, status: 'enviado con imagen', imagen });
        } else {
          await clientVenom.sendText(`${numero}@c.us`, mensajeAEnviar);
          resultados.push({ numero, status: 'enviado' });
        }

        console.log(`Esperando ${DELAY_MS / 1000} segundos antes de enviar el siguiente mensaje...`);
        await delay(DELAY_MS);
      } catch (err) {
        console.log(`Error enviando a ${numero}:`, err);
        if (err && err.stack) {
          console.log('Stack trace:', err.stack);
        }
        resultados.push({ numero, status: 'error', error: err && err.message ? err.message : String(err) });
      }
    }

    clearTimeout(timeout);
    enviando = false;
    console.log('Todos los mensajes procesados, enviando respuesta.');
    return res.status(200).json({
      success: true,
      message: 'Mensajes procesados',
      resultados,
    });
  } catch (error) {
    clearTimeout(timeout);
    enviando = false;
    console.log('Error general en el envío:', error);
    if (error && error.stack) {
      console.log('Stack trace:', error.stack);
    }
    return res.status(500).json({ success: false, error: error.message });
  }
});

app.listen(3000, () => {
  console.log('API de Venom escuchando en http://localhost:3000');
});
