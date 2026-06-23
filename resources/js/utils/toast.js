import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

function show(message, type = 'success') {
  const isDark = document.documentElement.classList.contains('dark');
  let background;
  if (type === 'error') {
    background = isDark ? 'linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%)' : 'linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)';
  } else {
    background = isDark ? 'linear-gradient(135deg, #064e3b 0%, #047857 100%)' : 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
  }

  Toastify({
    text: message,
    duration: 4000,
    close: true,
    gravity: 'bottom',
    position: 'left',
    stopOnFocus: true,
    style: {
      background,
      borderRadius: '12px',
      padding: '12px 20px',
      fontSize: '14px',
      fontWeight: '500',
      color: '#ffffff'
    }
  }).showToast();
}

export const toast = {
  success: (msg) => show(msg, 'success'),
  error: (msg) => show(msg, 'error')
};

export default toast;
