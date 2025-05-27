const venom = require('venom-bot');
const express = require('express');
const app = express();
app.use(express.json());

let clientVenom = null;
const MAX_NUMEROS = 50;

// Delay aleatorio entre 1 y 2 minutos (60000 a 120000 ms)
const getRandomDelay = () => Math.floor(Math.random() * 60000) + 60000;
const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

const isValidNumber = num => /^\d{10,13}$/.test(num);

venom
  .create({
    session: 'acrecer',
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

let enviando = false;

app.post('/send-message', async (req, res) => {
  if (enviando) {
    return res.status(429).json({ success: false, error: 'Ya hay un envío en proceso. Intenta más tarde.' });
  }
  enviando = true;

  // Responde de inmediato para evitar timeout en Postman
  res.status(200).json({ success: true, message: 'Envío iniciado en background.' });

  let { numeros, numero, mensaje, titulo } = req.body;

  console.log('Cuerpo recibido:', req.body);

  if (!clientVenom) {
    enviando = false;
    console.log('Cliente de Venom aún no está listo.');
    return;
  }

  // Asegura que 'numeros' sea un array válido
  if (!numeros && numero) {
    numeros = [numero];
  }
  if (!Array.isArray(numeros)) {
    numeros = [];
  }

  if (numeros.length === 0 || !mensaje) {
    enviando = false;
    console.log('Validación fallida:', { numeros, mensaje });
    return;
  }

  if (numeros.length > MAX_NUMEROS) {
    enviando = false;
    console.log(`No se pueden enviar más de ${MAX_NUMEROS} mensajes por solicitud.`);
    return;
  }

  numeros = numeros.filter(isValidNumber);
  if (numeros.length === 0) {
    enviando = false;
    console.log('Ningún número válido para enviar.');
    return;
  }

  const resultados = [];

  // El ciclo for con delay después de cada envío (excepto el último)
  (async () => {
    for (let i = 0; i < numeros.length; i++) {
      const num = numeros[i];
      try {
        let mensajeAEnviar = mensaje;
        if (titulo) {
          mensajeAEnviar = `*${titulo}*\n${mensaje}`;
        }

        console.log(`(${i + 1}/${numeros.length}) Enviando a: ${num}, Título: ${titulo ? titulo : 'No hay título'}`);

        await clientVenom.sendText(`${num}@c.us`, mensajeAEnviar);
        resultados.push({ numero: num, status: 'enviado' });

      } catch (err) {
        resultados.push({ numero: num, status: 'error', error: err.message });
        console.log(`Error enviando a ${num}:`, err.message);
      }

      // Delay después de cada mensaje, excepto el último
      if (i < numeros.length - 1) {
        const delayTime = getRandomDelay();
        console.log(`Esperando ${Math.round(delayTime / 1000)} segundos antes de enviar el siguiente mensaje...`);
        await delay(delayTime);
      }
    }

    enviando = false;
    console.log('Todos los mensajes procesados.');
    // Si quieres guardar los resultados, puedes hacerlo aquí
  })();
});

app.listen(3000, () => {
  console.log('API de Venom escuchando en http://localhost:3000');
});
