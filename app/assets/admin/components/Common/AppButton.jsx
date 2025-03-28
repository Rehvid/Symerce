const AppButton = ({ children, id, variant, additionalClasses = '', type = 'button', ...props }) => {
    const variants = {
        primary: 'bg-primary text-white hover:bg-primary-stronger',
        secondary: 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-300',
        link: 'bg-white text-gray-700 text-sm hover:bg-gray-100 hover:text-gray-900',
    };

    return (
        <button
            id={id}
            type={type}
            className={`transition-all rounded-full cursor-pointer ${
                variant ? variants[variant] : ''
            } ${additionalClasses}`}
            {...props}
        >
            {children}
        </button>
    );
};

export default AppButton;
