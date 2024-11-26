const Tabs = ({ tabs, activeTab, onTabClick }) => {
  return (
    <ul className="space-y-2">
      {tabs.map((tab) => (
        <li
          key={tab.id}
          className={`cursor-pointer px-3 py-2 rounded-md text-gray-700 ${
            activeTab === tab.id
              ? "bg-indigo-600 text-white"
              : "hover:bg-gray-100"
          }`}
          onClick={() => onTabClick(tab.id)}
        >
          {tab.label}
        </li>
      ))}
    </ul>
  );
};

export default Tabs;
