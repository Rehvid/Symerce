import React from 'react';
import AppInput from '@/admin/components/form/AppInput';
import { validationRules } from '@/admin/utils/validationRules';
import FormCategoryTree from '@/admin/components/category-tree/FormCategoryTree';
import AppTextarea from '@/admin/components/form/AppTextarea';
import { Controller } from 'react-hook-form';

const CategoryFormMainColumn = ({ register, errors, categoryData, params, watch, control }) => {
    return (
        <>
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
                isRequired
            />

            <AppInput
              {...register('slug')}
              type="text"
              id="slug"
              label="Przyjazny url"
              hasError={errors.hasOwnProperty('slug')}
              errorMessage={errors?.slug?.message}
            />

            <Controller
                name="description"
                control={control}
                defaultValue=""
                render={({ field }) => <AppTextarea value={field.value} onChange={field.onChange} title="Opis" />}
            />

            <FormCategoryTree
                titleSection="Kategoria nadrzędna"
                hasError={errors.hasOwnProperty('parentCategoryId')}
                errorMessage={errors?.parentCategoryId?.message}
                register={register('parentCategoryId')}
                disabledCategoryId={params.id ?? null}
                categories={categoryData.tree || []}
                selected={categoryData.parentCategoryId}
                watch={watch}
                nameWatchedValue="parentCategoryId"
            />
        </>
    );
};

export default CategoryFormMainColumn;
