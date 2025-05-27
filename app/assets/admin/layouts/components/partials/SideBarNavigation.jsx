import NavigationItem from '@/admin/layouts/components/navigation/NavigationItem';
import DashboardIcon from '@/images/icons/dashboard.svg';
import FoldersIcon from '@/images/icons/folders.svg';
import Submenu from '@/admin/layouts/components/navigation/Submenu';
import ProductIcon from '@/images/icons/assembly.svg';
import ShoppingCartIcon from '@/images/icons/shopping-cart.svg';
import TagIcon from '@/images/icons/tag.svg';
import CarrierIcon from '@/images/icons/carrier.svg';
import DeliveryTimeIcon from '@/images/icons/delivery-time.svg';
import CurrencyIcon from '@/images/icons/currency.svg';
import UsersIcon from '@/images/icons/users.svg';
import SettingIcon from '@/images/icons/settings.svg';
import PaymentIcon from '@/images/icons/payment.svg';
import WorldIcon from '@/images/icons/world.svg';

const SideBarNavigation = () => (
    <ul className="flex flex-col gap-4">
        <NavigationItem to={'dashboard'}>
            <DashboardIcon className="w-[24px] h-[24px]" />
            <span> Dashboard</span>
        </NavigationItem>
        <NavigationItem to={'categories'}>
            <FoldersIcon className="w-[24px] h-[24px]" />
            <span> Kategorie</span>
        </NavigationItem>
        <Submenu
            buttonLabel={
                <span className="flex gap-2 items-center">
                    <ProductIcon className="w-[24px] h-[24px]" /> Produkty
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
            <TagIcon className="w-[24px] h-[24px]" />
            <span>Tagi</span>
        </NavigationItem>
        <NavigationItem to={'carriers'}>
            <CarrierIcon className="w-[24px] h-[24px]" />
            <span>Dostawcy</span>
        </NavigationItem>
        <NavigationItem to={'delivery-time'}>
            <DeliveryTimeIcon className="w-[24px] h-[24px]" />
            <span>Czasy dostawy</span>
        </NavigationItem>
        <NavigationItem to={'currencies'}>
            <CurrencyIcon className="w-[24px] h-[24px]" />
            <span>Waluty</span>
        </NavigationItem>
      <NavigationItem to={'payment-methods'}>
        <PaymentIcon className="w-[24px] h-[24px]" />
        <span>Płatności</span>
      </NavigationItem>
        <NavigationItem to={'users'}>
            <UsersIcon className="w-[24px] h-[24px]" />
            <span>Users</span>
        </NavigationItem>
        <Submenu
          buttonLabel={
            <span className="flex gap-2 items-center">
              <ShoppingCartIcon className="w-[24px] h-[24px]" /> Zamówienia
            </span>
          }
        >
          <NavigationItem to={'orders'}>
            <span>Zamówienia</span>
          </NavigationItem>
        </Submenu>
        <NavigationItem to={'settings'}>
            <SettingIcon className="w-[24px] h-[24px]" />
            <span>Ustawienia</span>
        </NavigationItem>
      <NavigationItem to={'countries'}>
        <WorldIcon className="w-[24px] h-[24px]" />
        <span>Kraje</span>
      </NavigationItem>
    </ul>
);

export default SideBarNavigation;
