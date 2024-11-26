const InputField = ({ label, value, onChange }) => {
  return (
    <div className="border-b border-gray-200 pb-4 flex items-center">
      <span className="mr-2 text-gray-700 flex-shrink-0 font-bold">
        {label}
      </span>
      <input
        type="text"
        value={value}
        onChange={(e) => onChange(e.target.value)}
        className="flex-grow px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full"
      />
    </div>
  );
};

export default InputField;
