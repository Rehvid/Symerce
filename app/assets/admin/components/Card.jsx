const Card = ({ children, additionalClasses = '' }) => {
    return <div className={`rounded-xl border border-gray-200 bg-white p-6 ${additionalClasses}`}>{children}</div>;
};

export default Card;
