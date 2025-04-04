import React from 'react';
import AppSwitch from '@/admin/components/form/AppSwitch';
import AppFormSideColumn from '@/admin/components/form/AppFormSideColumn';

const CategoryFormSideColumn = ({ register }) => {
    return (
        <AppFormSideColumn sectionTitle="Attribute">
            <AppSwitch label="Aktywny" {...register('isActive')} />
        </AppFormSideColumn>
    );
};
export default CategoryFormSideColumn;
