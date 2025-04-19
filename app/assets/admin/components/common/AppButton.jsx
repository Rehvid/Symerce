const AppButton = ({ children, id, variant, additionalClasses = '', type = 'button', ...props }) => {
    const variants = {
        primary: 'bg-primary text-tertiary hover:bg-primary-hover',
        secondary: 'bg-secondary text-tertiary hover:bg-secondary-hover ',
        link: 'bg-white text-gray-700 hover:bg-gray-100 hover:text-gray-900',
        sideBar: 'text-gray-700 hover:bg-gray-100',
    };

    return (
        <button
            id={id}
            type={type}
            className={`transition-all rounded-lg cursor-pointer  ${variant ? variants[variant] : ''} ${additionalClasses}`}
            {...props}
        >
            {children}
        </button>
    );
};

export default AppButton;
