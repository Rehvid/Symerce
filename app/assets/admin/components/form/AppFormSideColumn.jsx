import Card from '@/admin/components/Card';
import React from 'react';

const AppFormSideColumn = ({ sectionTitle, children }) => (
    <Card additionalClasses="w-[500px] h-full">
        <div className="flex flex-col gap-4">
            <h3 className="text-lg font-semibold">{sectionTitle}</h3>
            {children}
        </div>
    </Card>
);

export default AppFormSideColumn;
