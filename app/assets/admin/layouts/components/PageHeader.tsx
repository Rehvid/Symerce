import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import React, { ReactNode } from 'react';

interface PageHeaderProps {
    title: string;
    children?: ReactNode;
}

const PageHeader: React.FC<PageHeaderProps> = ({ title, children }) => {
    return (
        <div className="flex justify-between flex-wrap items-center mb-[1.5rem] gap-4">
            <Heading level={HeadingLevel.H1}>{title}</Heading>
            <div className="w-full sm:w-auto">{children}</div>
        </div>
    );
};

export default PageHeader;
