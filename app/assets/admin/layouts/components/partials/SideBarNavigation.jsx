import NavigationItem from '@/admin/layouts/components/navigation/NavigationItem';
import DashboardIcon from '@/images/icons/dashboard.svg';
import FoldersIcon from '@/images/icons/folders.svg';
import Submenu from '@/admin/layouts/components/navigation/Submenu';
import ProductIcon from '@/images/icons/assembly.svg';
import TagIcon from '@/images/icons/tag.svg';
import CarrierIcon from '@/images/icons/carrier.svg';
import DeliveryTimeIcon from '@/images/icons/delivery-time.svg';
import CurrencyIcon from '@/images/icons/currency.svg';
import UsersIcon from '@/images/icons/users.svg';
import SettingIcon from '@/images/icons/settings.svg';

const SideBarNavigation = () => (
    <ul className="flex flex-col gap-4">
        <NavigationItem to={'dashboard'}>
            <DashboardIcon />
            <span> Dashboard</span>
        </NavigationItem>
        <NavigationItem to={'categories'}>
            <FoldersIcon />
            <span> Kategorie</span>
        </NavigationItem>
        <Submenu
            buttonLabel={
                <span className="flex gap-2 items-center">
                    <ProductIcon /> Produkty
                </span>
            }
        >
            <NavigationItem to={'products'}>
                <span>Produkty</span>
            </NavigationItem>
            <NavigationItem to={'products/attributes'}>
                <span>Atrybuty</span>
            </NavigationItem>
            <NavigationItem to={'products/vendors'}>
                <span>Producenci</span>
            </NavigationItem>
        </Submenu>
        <NavigationItem to={'tags'}>
            <TagIcon />
            <span>Tagi</span>
        </NavigationItem>
        <NavigationItem to={'carriers'}>
            <CarrierIcon />
            <span>Dostawcy</span>
        </NavigationItem>
        <NavigationItem to={'delivery-time'}>
            <DeliveryTimeIcon />
            <span>Czasy dostawy</span>
        </NavigationItem>
        <NavigationItem to={'currencies'}>
            <CurrencyIcon />
            <span>Waluty</span>
        </NavigationItem>
        <NavigationItem to={'users'}>
            <UsersIcon />
            <span>Users</span>
        </NavigationItem>
        <NavigationItem to={'settings'}>
            <SettingIcon />
            <span>Ustawienia</span>
        </NavigationItem>
    </ul>
);

export default SideBarNavigation;
