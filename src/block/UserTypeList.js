import { useState } from "@wordpress/element";
import HelpText from "./components/HelpText.js";

const DEFAULT_USER_TYPES = [
  { id: "buyer", name: "Buyer" },
  { id: "seller", name: "Seller" },
  { id: "member", name: "Member" }
];

export default function UserTypeList({ onSelect, selectedUserTypeID }) {
  const [userTypes] = useState(DEFAULT_USER_TYPES);

  const handleChange = (userTypeID) => {
    onSelect(userTypeID);
    console.log("Selected", userTypeID);
  };

  return (
    <div style={{ marginTop: "30px" }}>
      <h3 style={{ marginBottom: "10px" }}>User Type</h3>
      <HelpText info="Choose the user type who will receive emails generated from this template." />
      <div
        style={{
          display: "flex",
          flexDirection: "column",
          gap: "6px",
          border: "1px solid #ccc",
          padding: "10px",
          borderRadius: "4px",
          backgroundColor: "#fff",
        }}
      >
        {userTypes.map((userType) => (
          <label
            key={userType.id}
            style={{
              display: "block",
              padding: "8px",
              marginBottom: "6px",
              backgroundColor:
                selectedUserTypeID === userType.id ? "#e0f7fa" : "#f9f9f9",
              border: "1px solid #ccc",
              borderRadius: "4px",
              cursor: "pointer",
            }}
          >
            <input
              type="radio"
              name="user-type"
              value={userType.id}
              checked={selectedUserTypeID === userType.id}
              onChange={(e) => handleChange(e.target.value)}
              style={{ marginRight: "8px" }}
            />
            <strong>{userType.name}</strong>
          </label>
        ))}
      </div>
    </div>
  );
}
