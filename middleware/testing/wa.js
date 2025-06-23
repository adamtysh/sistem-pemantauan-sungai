const axios = require('axios');

const sendWhatsAppMessage = async () => {
  const data = new URLSearchParams();
  data.append('target', '6283861070642'); // Ganti nomor
  data.append('message', 'Halo dari Node.js via Fonnte');
  data.append('delay', '2');
  data.append('countryCode', '62');

  try {
    const response = await axios.post('https://api.fonnte.com/send', data.toString(), {
      headers: {
        'Authorization': 'z6u7shMHbhvapLM83zyf',
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });

    console.log('Pesan terkirim:', response.data);
  } catch (error) {
    console.error('Gagal kirim pesan:', error.response?.data || error.message);
  }
};

sendWhatsAppMessage();
