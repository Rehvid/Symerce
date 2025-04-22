import NavigationItem from '@/admin/layouts/components/navigation/NavigationItem';
import DashboardIcon from '@/images/icons/dashboard.svg';
import FoldersIcon from '@/images/icons/folders.svg';
import ProductIcon from '@/images/icons/assembly.svg';
import UsersIcon from '@/images/icons/users.svg';
import SettingIcon from '@/images/icons/settings.svg';
import TagIcon from '@/images/icons/tag.svg';
import CurrencyIcon from '@/images/icons/currency.svg';
import CarrierIcon from '@/images/icons/carrier.svg';
import DeliveryTimeIcon from '@/images/icons/delivery-time.svg';
import Submenu from '@/admin/layouts/components/navigation/Submenu';

const SideBar = () => {
    return (
        <aside className="fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white text-gray-900 h-screen transition-all duration-300 ease-in-out z-50 border-r border-gray-200 w-[290px] -translate-x-full lg:translate-x-0">
            <div className="py-8 flex justify-start">
                <a>
                    <img src="logo.svg" />
                </a>
            </div>
            <div className="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
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
            </div>
        </aside>
    );
};

export default SideBar;
