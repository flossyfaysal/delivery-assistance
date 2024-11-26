import { useState } from "react";
import apiFetch from "@wordpress/api-fetch";
import ReactDOM from "react-dom/client";
import Message from "./components/Message";
import Tabs from "./components/Tabs";
import InputField from "./components/InputField";
import CheckboxField from "./components/CheckboxField";
import SaveButton from "./components/SaveButton";

const SettingsApp = () => {
  const [activeTab, setActiveTab] = useState("general");
  const [options, setOptions] = useState(DeliveryAssistanceData.options || {});
  const [message, setMessage] = useState("");

  const handleChange = (key, value) => {
    setOptions({ ...options, [key]: value });
  };

  const saveSettings = () => {
    apiFetch({
      path: "/wp-json/delivery-assistance/v1/save-settings",
      method: "POST",
      headers: {
        "X-WP-Nonce": DeliveryAssistanceData.nonce,
      },
      data: {
        deliver_assistance_option: options,
      },
    })
      .then((response) => {
        if (response.data) {
          setOptions(response.data); // Update state with the latest options
          setMessage("");
          setTimeout(() => setMessage("Settings saved successfully!"), 0);
        } else {
          setMessage("");
          setTimeout(() => setMessage("Error saving settings."), 0);
        }
      })
      .catch(() => setMessage("Error saving settings."));
  };

  const tabs = [
    { id: "general", label: "General Settings" },
    { id: "api", label: "API Settings" },
    { id: "advanced", label: "Advanced Settings" },
  ];

  return (
    <div className="mt-5 mr-5 p-8 flex bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
      {/* Sidebar */}
      <div className="w-1/4 bg-gray-50 border-r border-gray-200 p-4">
        <h2 className="text-lg font-semibold text-gray-700 mb-4">
          Delivery Assistance
        </h2>
        <Tabs tabs={tabs} activeTab={activeTab} onTabClick={setActiveTab} />
      </div>

      {/* Content Area */}
      <div className="w-3/4 p-12 bg-gray-50 border-l border-gray-200">
        <h1 className="text-xl font-bold text-gray-800 mb-6">
          {tabs.find((tab) => tab.id === activeTab)?.label}
        </h1>

        {/* Message */}
        {message && <Message message={message} />}

        {/* Settings Form */}
        <div className="space-y-8 border-t border-gray-200 pt-8">
          {activeTab === "general" && (
            <>
              <InputField
                label={"Default Status"}
                value={options.default_status || ""}
                onChange={(value) => handleChange("default_status", value)}
              />
              <CheckboxField
                label={"User Auth"}
                checked={options.enable_feature}
                onChange={(checked) => handleChange("enable_feature", checked)}
                isEnabled={options.enable_feature}
              />
            </>
          )}

          {activeTab === "api" && (
            <InputField
              label={"Redirect"}
              value={options.redirect}
              onChange={(value) => handleChange("redirect", value)}
            />
          )}

          {activeTab === "advanced" && (
            <CheckboxField
              label={"Advanced"}
              checked={options.advanced}
              onChange={(checked) => handleChange("advanced", checked)}
              isEnabled={options.advanced}
            />
          )}
        </div>

        {/* Save Button */}
        <SaveButton onClick={saveSettings} />
      </div>
    </div>
  );
};

export default SettingsApp;

const root = ReactDOM.createRoot(
  document.getElementById("delivery-assistance-settings-app")
);

root.render(
  <React.StrictMode>
    <SettingsApp />
  </React.StrictMode>
);
