// Toast wrapper using toastify-js
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

function show(message, options = {}) {
  const {
    duration = 3000,
    gravity = 'top',
    position = 'right',
    background = 'linear-gradient(to right, #00b09b, #96c93d)',
  } = options;

  Toastify({
    text: message,
    duration,
    gravity,
    position,
    style: { background },
  }).showToast();
}

export default {
  success(msg, opts = {}) { return show(msg, { background: 'linear-gradient(to right, #28a745, #72d68a)', ...opts }); },
  error(msg, opts = {}) { return show(msg, { background: 'linear-gradient(to right, #dc3545, #f06d6d)', ...opts }); },
  info(msg, opts = {}) { return show(msg, { background: 'linear-gradient(to right, #007bff, #66a3ff)', ...opts }); },
  raw(msg, opts = {}) { return show(msg, opts); },
};
