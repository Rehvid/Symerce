import { NavLink } from 'react-router-dom';

const AppLink = ({ to, state = {}, children, variant = 'default', additionalClasses = '', ...props }) => {
    const variants = {
        sidebar: 'text-gray-700 rounded-lg hover:bg-primary hover:text-white',
        default: 'text-sm text-gray-500 hover:text-primary',
        button: 'text-sm rounded-lg font-medium text-gray-700 hover:bg-primary-hover hover:text-white',
    };

    const activeVariants = {
        sidebar: 'bg-primary text-white font-medium hover:bg-primary',
        default: '',
        button: '',
    };

    return (
        <NavLink
            {...props}
            end
            to={to}
            state={state}
            className={({ isActive }) =>
                `transition-all ${variants[variant]} ${isActive ? activeVariants[variant] : ''} ${additionalClasses}`
            }
        >
            {children}
        </NavLink>
    );
};

export default AppLink;
