import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import Card from '@admin/common/components/Card';
import React, { FC } from 'react';

interface DashboardCardProps {
    icon: React.ReactNode;
    title: string;
    count: number;
}

const DashboardCard: FC<DashboardCardProps> = ({icon, title, count}) => (
    <Card additionalClasses="w-full flex  gap-[2rem] border border-gray-200">
        <div className="bg-gray-100 h-12 w-12 flex justify-center items-center rounded-2xl">
            {icon}
        </div>
        <div className="flex flex-col">
            <span className="text-sm text-gray-500">{title}</span>
            <Heading level={HeadingLevel.H2}>{count}</Heading>
        </div>
    </Card>
)

export default DashboardCard;
