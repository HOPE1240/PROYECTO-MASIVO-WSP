const venom = require('venom-bot');
const express = require('express');
const app = express();
app.use(express.json());

let clientVenom = null;

venom
  .create({
    session: 'session-name', // Nombre único para la sesión
    multidevice: true,       // Habilita el modo multidispositivo
    headless: true,          // Usa el nuevo modo Headless
    browserArgs: [
      '--no-sandbox',
      '--disable-setuid-sandbox',
      '--disable-dev-shm-usage',
      '--disable-accelerated-2d-canvas',
      '--no-first-run',
      '--no-zygote',
      '--single-process', // Necesario para entornos de Docker
      '--disable-gpu'
    ],
    executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', // Ruta al navegador Chrome
  })
  .then((client) => {
    clientVenom = client;
    console.log('Sesión creada con éxito');
  })
  .catch((error) => {
    console.log('Error creando la sesión:', error);
  });

const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

// Nueva función para obtener un retraso aleatorio entre 1 y 3 minutos
const getRandomDelay = () => Math.floor(Math.random() * 120 + 60) * 1000; // Retraso aleatorio entre 1 y 3 minutos

app.post('/send-message', async (req, res) => {
  let { numeros, numero, mensaje } = req.body;

  console.log('Cuerpo recibido:', req.body);

  if (!clientVenom) {
    return res.status(500).json({ success: false, error: 'Cliente de Venom aún no está listo.' });
  }

  if (!numeros && numero) {
    numeros = [numero];
  }

  if (!numeros || !Array.isArray(numeros) || numeros.length === 0 || !mensaje) {
    console.log('Validación fallida:', { numeros, mensaje });
    return res.status(400).json({ success: false, error: 'Se requieren un número o una lista de números y un mensaje.' });
  }

  const resultados = [];

  // Inicia el ciclo de envío de mensajes
  for (const num of numeros) {
    try {
      await clientVenom.sendText(`${num}@c.us`, mensaje);
      resultados.push({ numero: num, status: 'enviado' });
    } catch (err) {
      resultados.push({ numero: num, status: 'error', error: err.message });
    }

    // Retraso aleatorio de entre 1 y 3 minutos entre mensajes
    const delayTime = getRandomDelay();
    console.log(`Esperando ${delayTime / 1000} segundos antes de enviar el siguiente mensaje...`);
    await delay(delayTime);
  }

  return res.status(200).json({
    success: true,
    message: 'Mensajes procesados con retraso aleatorio',
    resultados,
  });
});

app.listen(3000, () => {
  console.log('API de Venom escuchando en http://localhost:3000');
});
