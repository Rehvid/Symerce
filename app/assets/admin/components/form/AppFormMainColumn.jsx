import React from 'react';
import Card from '@/admin/components/Card';

const AppFormMainColumn = ({ sectionTitle, children }) => (
    <Card>
        <h3 className="text-lg font-semibold">{sectionTitle}</h3>
        <div className="flex flex-col gap-[40px] mt-5">{children}</div>
    </Card>
);

export default AppFormMainColumn;
