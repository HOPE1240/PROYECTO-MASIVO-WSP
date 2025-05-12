const venom = require('venom-bot');
const express = require('express');
const app = express();
app.use(express.json());

let clientVenom = null;
let solicitudProcesada = false; // Variable para rastrear si ya se procesó una solicitud válida

// Crear sesión de Venom
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

// Función para pausar la ejecución por un tiempo determinado
const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

// Función para generar un retraso aleatorio entre 1 y 30 segundos
const getRandomDelay = () => Math.floor(Math.random() * 30 + 1) * 1000;

// API para enviar mensajes con retraso aleatorio
app.post('/send-message', async (req, res) => {
  // Verificar si ya se procesó una solicitud válida
  if (solicitudProcesada) {
    console.log('Solicitud rechazada: ya se procesó una solicitud válida.');
    return res.status(403).json({ success: false, error: 'Ya se procesó una solicitud válida. No se aceptan más solicitudes.' });
  }

  let { numeros, numero, mensaje } = req.body;

  // Depuración: Verifica qué datos está recibiendo el servidor
  console.log('Cuerpo recibido:', req.body);

  if (!clientVenom) {
    return res.status(500).json({ success: false, error: 'Cliente de Venom aún no está listo.' });
  }

  // Si se envía un solo número en "numero", conviértelo en un array
  if (!numeros && numero) {
    numeros = [numero];
  }

  // Validación de los datos
  if (!numeros || !Array.isArray(numeros) || numeros.length === 0 || !mensaje) {
    console.log('Validación fallida:', { numeros, mensaje });
    return res.status(400).json({ success: false, error: 'Se requieren un número o una lista de números y un mensaje.' });
  }

  const resultados = [];

  for (const num of numeros) {
    try {
      await clientVenom.sendText(`${num}@c.us`, mensaje);
      resultados.push({ numero: num, status: 'enviado' });
    } catch (err) {
      resultados.push({ numero: num, status: 'error', error: err.message });
    }

    // Retraso aleatorio entre mensajes
    const delayTime = getRandomDelay();
    console.log(`Esperando ${delayTime / 1000} segundos antes de enviar el siguiente mensaje...`);
    await delay(delayTime);
  }

  // Marcar la solicitud como procesada
  solicitudProcesada = true;

  return res.status(200).json({
    success: true,
    message: 'Mensajes procesados con retraso aleatorio',
    resultados,
  });
});

// Iniciar servidor Express
app.listen(3000, () => {
  console.log('API de Venom escuchando en http://localhost:3000');
});