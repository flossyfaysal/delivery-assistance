import { useState } from "react";
import apiFetch from "@wordpress/api-fetch";
import ReactDOM from "react-dom/client";

const App = () => {
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
          setMessage("Settings saved successfully!");
        } else {
          setMessage("Settings saved, but no data returned.");
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
        <h2 className="text-lg font-semibold text-gray-700 mb-4">Menu</h2>
        <ul className="space-y-2">
          {tabs.map((tab) => (
            <li
              key={tab.id}
              className={`cursor-pointer px-3 py-2 rounded-md text-gray-700 ${
                activeTab === tab.id
                  ? "bg-indigo-600 text-white"
                  : "hover:bg-gray-100"
              }`}
              onClick={() => setActiveTab(tab.id)}
            >
              {tab.label}
            </li>
          ))}
        </ul>
      </div>

      {/* Content Area */}
      <div className="w-3/4 p-12 bg-gray-50 border-l border-gray-200">
        <h1 className="text-xl font-bold text-gray-800 mb-6">
          {tabs.find((tab) => tab.id === activeTab)?.label}
        </h1>

        {/* Message */}
        {message && (
          <div className="mb-4 p-3 rounded-md text-white bg-green-500">
            {message}
          </div>
        )}

        {/* Settings Form */}
        <div className="space-y-8 border-t border-gray-200 pt-8">
          {activeTab === "general" && (
            <>
              <div className="border-b border-gray-200 pb-8">
                <label className="inline-flex items-center w-full">
                  <span className="mr-2 text-gray-700 flex-shrink-0 font-bold">
                    Default Status
                  </span>
                  <input
                    type="text"
                    value={options.default_status || ""}
                    onChange={(e) =>
                      handleChange("default_status", e.target.value)
                    }
                    className="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  />
                </label>
              </div>
              <div className="border-b border-gray-200 pb-8">
                <label className="inline-flex items-center cursor-pointer">
                  <span className="mr-2 text-gray-700 flex-shrink-0 font-bold">
                    Enable Feature
                  </span>
                  <div className="relative">
                    <input
                      type="checkbox"
                      checked={options.enable_feature || false}
                      onChange={(e) =>
                        handleChange("enable_feature", e.target.checked)
                      }
                      className="sr-only"
                    />
                    <div
                      className={`block w-12 h-6 rounded-full transition-all duration-300 ${
                        options.enable_feature ? "bg-blue-500" : "bg-gray-300"
                      }`}
                    ></div>
                    <div
                      className={`dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all duration-300 ${
                        options.enable_feature ? "transform translate-x-6" : ""
                      }`}
                    ></div>
                  </div>
                </label>
              </div>
            </>
          )}

          {activeTab === "api" && (
            <div className="border-b border-gray-200 pb-4">
              <label className="block mb-4">
                <span className="block text-sm font-medium text-gray-700">
                  API Key
                </span>
                <input
                  type="text"
                  value={options.api_key || ""}
                  onChange={(e) => handleChange("api_key", e.target.value)}
                  className="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
              </label>
            </div>
          )}

          {activeTab === "advanced" && (
            <div className="border-b border-gray-200 pb-4">
              <p className="text-gray-500">Advanced settings coming soon...</p>
            </div>
          )}
        </div>

        {/* Save Button */}
        <button
          onClick={saveSettings}
          className="mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700"
        >
          Save Settings
        </button>
      </div>
    </div>
  );
};

export default App;

const root = ReactDOM.createRoot(
  document.getElementById("delivery-assistance-settings-app")
);
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
