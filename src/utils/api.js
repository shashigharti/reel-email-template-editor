import apiFetch from '@wordpress/api-fetch';

export function fetchTemplates() {
  return apiFetch({ path: '/reel/v1/templates' });
}

export function fetchHooks() {
  return apiFetch({ path: '/reel/v1/hooks' });
}

export function fetchTemplateBySlug(slug) {
  let path = `/reel/v1/template/${encodeURIComponent(slug)}`;
  return apiFetch({ path });
}

export function saveTemplate(id, data) {
  return apiFetch({
    path: `/reel/v1/template/${id}`,
    method: 'POST',
    data
  });
}

export function importTemplate() {
  return apiFetch({
    path: '/reel/v1/template/import',
    method: 'POST'
  });
}

export function deleteTemplate(id) {
  return apiFetch({
    path: `/reel/v1/template/${encodeURIComponent(id)}`,
    method: 'DELETE',
  });
}

export function fetchVariables() {
  return apiFetch({ path: '/reel/v1/variables' });
}

