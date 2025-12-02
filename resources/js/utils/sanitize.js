import DOMPurify from 'dompurify';
import { sanitizeUrl as braintreeSanitizeUrl } from '@braintree/sanitize-url';

export function sanitizeHtml(input) {
  const html = String(input ?? '');
  return DOMPurify.sanitize(html);
}

export function safeUrl(input) {
  const url = String(input ?? '');
  const sanitized = braintreeSanitizeUrl(url);
  return sanitized === 'about:blank' ? '#' : sanitized;
}

export default { sanitizeHtml, safeUrl };
