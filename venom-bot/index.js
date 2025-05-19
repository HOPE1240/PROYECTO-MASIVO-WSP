const venom = require('venom-bot');
const express = require('express');
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
// Cambia aquí el delay fijo (por ejemplo, 7 segundos)
const DELAY_MS = 7000;

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
    let { numeros, numero, mensaje, imagen, titulo } = req.body;

    console.log('Cuerpo recibido:', req.body);

    if (!clientVenom) {
      clearTimeout(timeout);
      enviando = false;
      return res.status(500).json({ success: false, error: 'Cliente de Venom aún no está listo.' });
    }

    if (!numeros && numero) {
      numeros = [numero];
    }

    if (!numeros || !Array.isArray(numeros) || numeros.length === 0 || !mensaje) {
      clearTimeout(timeout);
      enviando = false;
      console.log('Validación fallida:', { numeros, mensaje });
      return res.status(400).json({ success: false, error: 'Se requieren un número o una lista de números y un mensaje.' });
    }

    if (numeros.length > MAX_NUMEROS) {
      clearTimeout(timeout);
      enviando = false;
      return res.status(400).json({ success: false, error: `No se pueden enviar más de ${MAX_NUMEROS} mensajes por solicitud.` });
    }

    numeros = numeros.filter(isValidNumber);
    if (numeros.length === 0) {
      clearTimeout(timeout);
      enviando = false;
      return res.status(400).json({ success: false, error: 'Ningún número válido para enviar.' });
    }

    const resultados = [];

    for (const num of numeros) {
      try {
        // Incluye el título en el mensaje si existe
        let mensajeAEnviar = mensaje;
        if (titulo) {
          mensajeAEnviar = `*${titulo}*\n${mensaje}`;
        }

        console.log(`Enviando a: ${num}, Imagen: ${imagen ? imagen : 'No hay imagen'}, Título: ${titulo ? titulo : 'No hay título'}`);

        if (imagen) {
          await clientVenom.sendImage(`${num}@c.us`, imagen, 'imagen.jpg', mensajeAEnviar);
          resultados.push({ numero: num, status: 'enviado con imagen', imagen });
        } else {
          await clientVenom.sendText(`${num}@c.us`, mensajeAEnviar);
          resultados.push({ numero: num, status: 'enviado' });
        }

        console.log(`Esperando ${DELAY_MS / 1000} segundos antes de enviar el siguiente mensaje...`);
        await delay(DELAY_MS);
      } catch (err) {
        resultados.push({ numero: num, status: 'error', error: err.message });
        console.log(`Error enviando a ${num}:`, err.message);
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
    return res.status(500).json({ success: false, error: error.message });
  }
});

app.listen(3000, () => {
  console.log('API de Venom escuchando en http://localhost:3000');
});
