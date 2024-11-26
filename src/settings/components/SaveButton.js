const SaveButton = ({ onClick }) => {
  return (
    <button
      onClick={onClick}
      className="mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700"
    >
      Save Settings
    </button>
  );
};

export default SaveButton;
