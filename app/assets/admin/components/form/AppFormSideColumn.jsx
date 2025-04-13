import Card from '@/admin/components/Card';
import React from 'react';
import Heading from '@/admin/components/common/Heading';

const AppFormSideColumn = ({ sectionTitle, children }) => (
    <Card additionalClasses="w-[500px] h-full">
        <div className="flex flex-col gap-5">
            <Heading level="h4" >{sectionTitle}</Heading>
            {children}
        </div>
    </Card>
);

export default AppFormSideColumn;
