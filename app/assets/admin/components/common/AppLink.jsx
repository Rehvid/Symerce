import { NavLink } from 'react-router-dom';

const AppLink = ({ to, children, variant = 'default', additionalClasses = '', ...props }) => {
    const variants = {
        sidebar: 'text-gray-700 rounded-full hover:bg-gray-100',
        default: 'text-sm text-gray-500 hover:text-primary',
        button: 'text-sm rounded-full font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900',
    };

    const activeVariants = {
        sidebar: 'bg-primary-light text-primary font-medium hover:bg-primary-light',
        default: '',
        button: '',
    };

    return (
        <NavLink
            {...props}
            end
            to={to}
            className={({ isActive }) =>
                `transition-all ${variants[variant]} ${isActive ? activeVariants[variant] : ''} ${additionalClasses}`
            }
        >
            {children}
        </NavLink>
    );
};

export default AppLink;
