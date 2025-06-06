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

import { ComponentType, SVGProps  } from 'react';

export interface NavChildItem {
    to: string;
    label: string;
}

export interface NavItem {
    to?: string;
    label: string;
    Icon?: ComponentType<SVGProps<SVGSVGElement>>;
    children?: NavChildItem[];
}

const navigationConfig: NavItem[] = [
    {
        to: 'dashboard',
        label: 'Dashboard',
        Icon: DashboardIcon,
    },
    {
        to: 'categories',
        label: 'Kategorie',
        Icon: FoldersIcon,
    },
    {
        label: 'Katalog Produktów',
        Icon: ProductIcon,
        children: [
            { to: 'products', label: 'Produkty' },
            { to: 'products/attributes', label: 'Atrybuty' },
        ],
    },
    {
        to: 'brands',
        label: 'Marki',
    },
    {
        to: 'tags',
        label: 'Tagi',
        Icon: TagIcon,
    },
    {
        to: 'carriers',
        label: 'Przewoźnicy',
        Icon: CarrierIcon,
    },
    {
        to: 'warehouses',
        label: 'Magazyny',
        Icon: DeliveryTimeIcon,
    },
    {
        to: 'currencies',
        label: 'Waluty',
        Icon: CurrencyIcon,
    },
    {
        to: 'payment-methods',
        label: 'Płatności',
        Icon: PaymentIcon,
    },
    {
        label: 'Osoby',
        Icon: UsersIcon,
        children: [
            { to: 'users', label: 'Użytkownicy' },
            { to: 'customers', label: 'Klienci' },
        ],
    },
    {
        label: 'Zamówienia',
        Icon: ShoppingCartIcon,
        children: [
            { to: 'orders', label: 'Zamówienia' },
            { to: 'carts', label: 'Koszyki zakupowe' },
        ],
    },
    {
        to: 'settings',
        label: 'Ustawienia',
        Icon: SettingIcon,
    },
    {
        to: 'countries',
        label: 'Kraje',
        Icon: WorldIcon,
    },
];

const SideBarNavigation = () => (
    <ul className="flex flex-col gap-4">
        {navigationConfig.map((item) => {
            if (item.children) {
                return (
                    <Submenu
                        key={item.label}
                        buttonLabel={
                            <span className="flex gap-2 items-center">
                                {item.Icon && <item.Icon className="w-[20px] h-[20px]" />}
                                {item.label}
                             </span>
                        }
                    >
                        {item.children.map((child) => (
                            <NavigationItem key={child.to} to={child.to}>
                                <span>{child.label}</span>
                            </NavigationItem>
                        ))}
                    </Submenu>
                );
            }

            return (
                <NavigationItem key={item.to} to={item.to}>
                    {item.Icon && <item.Icon className="w-[20px] h-[20px]" />}
                    <span> {item.label}</span>
                </NavigationItem>
            );
        })}
    </ul>
);


export default SideBarNavigation;
