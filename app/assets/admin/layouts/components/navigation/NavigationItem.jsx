import AppLink from '@/admin/components/common/AppLink';

const NavigationItem = ({ children, to }) => {
    return (
        <li>
            <AppLink to={to} variant="sidebar" additionalClasses="flex items-center gap-2 py-2 px-5">
                {children}
            </AppLink>
        </li>
    );
};

export default NavigationItem;
