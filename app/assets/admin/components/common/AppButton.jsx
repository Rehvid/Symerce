const AppButton = ({ children, id, variant, additionalClasses = '', type = 'button', ...props }) => {
    const variants = {
        primary: 'bg-primary text-white hover:bg-primary-hover',
        secondary: 'bg-secondary text-white hover:bg-secondary-hover ',
        link: 'bg-white text-gray-700 hover:bg-primary-hover hover:text-white',
        sideBar: 'text-gray-700 hover:bg-primary-hover hover:text-white',
        accept: 'bg-success text-black hover:bg-success-hover',
        decline: 'bg-error text-black hover:bg-error-hover',
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
