import Card from '../../../components/Card';
import React from 'react';
import AppSwitch from '@/shared/components/Form/AppSwitch';

const CategoryFormSideBar = ({ register }) => {
    return (
        <Card additionalClasses="w-[500px] h-full">
            <div className="flex flex-col gap-4">
                <h3 className="text-lg font-semibold">Attribute</h3>
                <AppSwitch label="Aktywny" {...register('isActive')} />
            </div>
        </Card>
    );
};
export default CategoryFormSideBar;
