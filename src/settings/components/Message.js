import { useEffect, useState } from "react";

const Message = ({ message }) => {
  const [visible, setVisible] = useState(true);

  useEffect(() => {
    setVisible(true);

    const timer = setTimeout(() => {
      setVisible(false);
    }, 3000);

    return () => clearTimeout(timer);
  }, [message]);

  if (!visible) return null;

  return (
    <div className="mb-4 p-3 rounded-md text-white bg-green-500">{message}</div>
  );
};

export default Message;
