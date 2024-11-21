{
  /* Sidebar */
}
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
</div>;

{
  /* Content Area */
}
<div className="w-3/4 p-12 bg-gray-50">
  <h1 className="text-xl font-bold text-gray-800 mb-6">
    {tabs.find((tab) => tab.id === activeTab)?.label}
  </h1>

  {/* Message */}
  {message && (
    <div className="mb-4 p-3 rounded-md text-white bg-green-500">{message}</div>
  )}

  {/* Settings Form */}
  <div className="space-y-8">
    {activeTab === "general" && (
      <div>
        <label className="block mb-4">
          <span className="block text-sm font-medium text-gray-700">
            Default Status
          </span>
          <input
            type="text"
            value={options.default_status || ""}
            onChange={(e) => handleChange("default_status", e.target.value)}
            className="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
          />
          <label className="inline-flex items-center cursor-pointer">
            <span className="mr-2 text-gray-700">Enable Feature</span>
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
        </label>
      </div>
    )}

    {activeTab === "api" && (
      <div>
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
      <div>
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
</div>;
