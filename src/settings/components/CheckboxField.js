const CheckboxField = ({ label, checked, onChange, isEnabled }) => {
  return (
    <div className="border-b border-gray-200 pb-8">
      <label className="inline-flex items-center cursor-pointer">
        <span className="mr-2 text-gray-700 flex-shrink-0 font-bold">
          {label}
        </span>
        <div className="relative">
          <input
            type="checkbox"
            checked={checked}
            onChange={(e) => onChange(e.target.checked)}
            className="sr-only"
          />
          <div
            className={`block w-12 h-6 rounded-full transition-all duration-300 ${
              isEnabled ? "bg-blue-500" : "bg-gray-300"
            }`}
          ></div>
          <div
            className={`dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-all duration-300 ${
              isEnabled ? "transform translate-x-6" : ""
            }`}
          ></div>
        </div>
      </label>
    </div>
  );
};

export default CheckboxField;
