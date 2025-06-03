export function generateSlug(text) {
  return text
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-')        // Replace spaces with -
    .replace(/[^\w-]/g, '');     // Remove all non-word chars except -
}
