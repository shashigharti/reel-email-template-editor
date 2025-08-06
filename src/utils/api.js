import apiFetch from "@wordpress/api-fetch";

const API_BASE = "/reel/v1";

export function fetchTemplates() {
  return apiFetch({ path: `${API_BASE}/templates` });
}

export function fetchHooks() {
  return apiFetch({ path: `${API_BASE}/hooks` });
}

export function fetchTemplateBySlug(slug) {
  let path = `${API_BASE}/template/${encodeURIComponent(slug)}`;
  return apiFetch({ path });
}

export function saveTemplate(id, data) {
  return apiFetch({
    path: `${API_BASE}/template/${id}`,
    method: "POST",
    data,
  });
}

export function importTemplate() {
  return apiFetch({
    path: `${API_BASE}/template/import`,
    method: "POST",
  });
}

export function exportTemplate() {
  return apiFetch({
    path: `${API_BASE}/template/export`,
    method: "POST",
  });
}

export function deleteTemplate(id) {
  return apiFetch({
    path: `${API_BASE}/template/${encodeURIComponent(id)}`,
    method: "DELETE",
  });
}

export function fetchVariables() {
  return apiFetch({ path: `${API_BASE}/variables` });
}

export async function fetchSettings(type) {
  return apiFetch({
    path: `${API_BASE}/settings?type=${encodeURIComponent(type)}`,
    method: "GET",
  });
}

export async function saveSettings(type, settings) {
  return apiFetch({
    path: `${API_BASE}/settings`,
    method: "POST",
    data: { type, settings },
  });
}
