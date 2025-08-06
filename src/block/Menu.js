import TemplateSelector from "./components/TemplateSelector";

export default function Menu({
  onImport,
  onExport,
  onAddNew,
  onTemplateSelect,
}) {
  return (
    <div
      style={{
        display: "flex",
        flexDirection: "row",
        alignItems: "center",
        gap: "20px",
        marginBottom: "10px",
      }}
    >
      <button
        type="button"
        onClick={onImport}
        style={{
          padding: "6px 12px",
          background: "#0073aa",
          color: "#fff",
          border: "none",
          borderRadius: "3px",
          cursor: "pointer",
          display: "flex",
          alignItems: "center",
          gap: "6px",
        }}
        title="Import Template"
      >
        <span role="img" aria-label="Import">
          📥
        </span>
        Import
      </button>
      <button
        type="button"
        onClick={onExport}
        style={{
          padding: "6px 12px",
          background: "#0073aa",
          color: "#fff",
          border: "none",
          borderRadius: "3px",
          cursor: "pointer",
          display: "flex",
          alignItems: "center",
          gap: "6px",
        }}
        title="Export Template"
      >
        <span role="img" aria-label="Export">
          📤 
        </span>
        Export
      </button>
      <button
        type="button"
        onClick={onAddNew}
        style={{
          padding: "6px 12px",
          background: "#00a32a",
          color: "#fff",
          border: "none",
          borderRadius: "3px",
          cursor: "pointer",
          display: "flex",
          alignItems: "center",
          gap: "6px",
        }}
        title="Add New Template"
      >
        <span role="img" aria-label="Add">
          ➕
        </span>
        Add New Template
      </button>
      {/* TODO: Enable the TemplateSelector component once template selection is implemented. */}
      {/* <TemplateSelector onTemplateSelect={onTemplateSelect} /> */}
    </div>
  );
}
