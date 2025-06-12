import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import React, { useEffect, useState } from 'react';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import UsersIcon from '@/images/icons/users.svg';
import ShoppingCartIcon from '@/images/icons/shopping-cart.svg';
import ProductIcon from '@/images/icons/assembly.svg';
import Card from '@admin/common/components/Card';
import DashboardCard from '@admin/modules/dashboard/components/DashboardCard';
import DashboardOrder from '@admin/modules/dashboard/components/DashboardOrder';
import DashboardBestsellers from '@admin/modules/dashboard/components/DashboardBestsellers';
import TableSkeleton from '@admin/common/components/skeleton/TableSkeleton';
import { DashboardData } from '@admin/modules/dashboard/interfaces/DashboardData';


const Dashboard: React.FC = () => {
    const { handleApiRequest } = useAdminApi();
    const [dashboardData, setDashboardData] = useState<DashboardData | null>(null);
    const [isLoading, setIsLoading] = useState<boolean>(false);

    useEffect(() => {
        setIsLoading(true);
        handleApiRequest(HttpMethod.GET, `admin/dashboard/`, {
            onSuccess: ({ data }) => {
                setDashboardData(data as DashboardData);
                setIsLoading(false);
            },
        }).catch(error => console.error(error));
    }, []);

    if (isLoading || !dashboardData) {
        return <TableSkeleton rowsCount={10} />;
    }

    return (
        <>
            <Heading level={HeadingLevel.H1}>Dashboard</Heading>

            <div className="mt-[2rem] grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-8">
                <DashboardCard icon={ <UsersIcon className="h-6 w-6 text-primary-500" />} title="Klienci" count={dashboardData?.customersCount || 0} />
                <DashboardCard icon={ <ShoppingCartIcon className="h-6 w-6 text-primary-500" />} title="Ilość zamówień" count={dashboardData?.ordersCount || 0} />
                <DashboardCard icon={<ShoppingCartIcon className="h-6 w-6 text-primary-500" />} title="Aktywne koszyki" count={dashboardData?.activeCartsCount || 0} />
                <DashboardCard icon={ <ProductIcon className="h-6 w-6 text-primary-500" />} title="Produkty" count={dashboardData?.productsCount || 0} />
            </div>

            <Card additionalClasses="mt-[2rem] border border-gray-200 ">
                <DashboardOrder orders={dashboardData.orders} />
            </Card>
            <Card additionalClasses="mt-[2rem] border border-gray-200">
                <DashboardBestsellers  bestsellers={dashboardData.bestSellers} />
            </Card>
        </>
    );
};

export default Dashboard;
