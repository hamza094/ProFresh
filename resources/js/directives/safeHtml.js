import { sanitizeHtml } from '../utils/sanitize';

export default {
  bind(el, binding) {
    el.innerHTML = sanitizeHtml(binding.value);
  },
  update(el, binding) {
    if (binding.value !== binding.oldValue) {
      el.innerHTML = sanitizeHtml(binding.value);
    }
  },
};
