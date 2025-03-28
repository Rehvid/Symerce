import AppLink from '../Common/AppLink';

const NavigationItem = ({ children, to }) => {
    return (
        <li>
            <AppLink to={to} variant="sidebar" additionalClasses="flex items-center py-2 px-5">
                <div>{children}</div>
            </AppLink>
        </li>
    );
};

export default NavigationItem;
