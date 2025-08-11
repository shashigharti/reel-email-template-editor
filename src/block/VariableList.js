import { useState, useEffect } from "@wordpress/element";
import { Button } from "@wordpress/components";
import { fetchVariables } from "../utils/api";
import HelpText from "./components/HelpText.js";

export default function VariableList({ onInsert }) {
  const [variables, setVariables] = useState([]);
  const [copied, setCopied] = useState(false);

  useEffect(() => {
    fetchVariables()
      .then((data) => {
        const sortedData = [...data].sort((a, b) =>
          a.key.localeCompare(b.key)
        );
        if (data.length > 0) {
          setVariables(sortedData);
        }
      })
      .catch((error) => {
        console.error("Failed to fetch variables:", error);
      });
  }, []);

  const handleCopy = async (text) => {
    try {
      const variable = `{{${text}}}`;
      await navigator.clipboard.writeText(variable);
      setCopied(true);

      console.log("variable", variable);

      setTimeout(() => {
        setCopied(false);
      }, 2000);
    } catch (err) {
      console.error("Copy failed", err);
    }
  };

  return (
    <div style={{ marginTop: "30px" }}>
      <h3 style={{ marginBottom: "10px" }}>Insert Variables</h3>
      <HelpText
        info="Click to insert placeholders in the email template. 
      These will be replaced with real values when the email is sent. 
      Single click copies the variable name. Double click inserts it to editor."
      />
      <div
        style={{
          maxHeight: "220px",
          overflowY: "auto",
          border: "1px solid #ccc",
          borderRadius: "4px",
          backgroundColor: "#fff",
        }}
      >
        {variables.map((v) => (
          <Button
            key={v.key}
            onClick={() => handleCopy(v.key)}
            onDoubleClick={() => onInsert(v.key)}
            title={v.description}
            style={{
              textAlign: "left",
              width: "100%",
              whiteSpace: "normal",
              marginBottom: "0px",
              paddingBottom: "0px",
            }}
            onKeyDown={(e) => {
              if (e.key === " ") {
                e.preventDefault();
              }
            }}
          >
            <strong>{`{{${v.key}}}`}</strong>
          </Button>
        ))}
      </div>
      {copied == true && <span style={{fontWeight: 'bold'}}>Copied!</span>}
    </div>
  );
}
