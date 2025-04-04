import React from 'react';
import AppInput from '@/admin/components/form/AppInput';
import AppFormMainColumn from '@/admin/components/form/AppFormMainColumn';
import { validationRules } from '@/admin/utils/validationRules';
import FormCategoryTree from '@/admin/components/category-tree/FormCategoryTree';

const CategoryFormMainColumn = ({ register, errors, categoryData, params, watch }) => {
    return (
        <AppFormMainColumn sectionTitle="Basic">
            <AppInput
                {...register('name', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="name"
                label="Nazwa"
                hasError={errors.hasOwnProperty('name')}
                errorMessage={errors?.name?.message}
            />
            <AppInput
                {...register('description')}
                type="text"
                id="description"
                label="Opis"
                hasError={errors.hasOwnProperty('description')}
                errorMessage={errors?.description?.message}
            />

            <FormCategoryTree
                titleSection="Parent Category"
                hasError={errors.hasOwnProperty('parentCategoryId')}
                errorMessage={errors?.parentCategoryId?.message}
                register={register('parentCategoryId', {
                    ...validationRules.required(),
                })}
                disabledCategoryId={params.id ?? null}
                categories={categoryData.tree || []}
                selected={categoryData.parentCategoryId}
                watch={watch}
                nameWatchedValue="parentCategoryId"
            />
        </AppFormMainColumn>
    );
};

export default CategoryFormMainColumn;
