import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import FormCategoryTree from '@/admin/components/category-tree/FormCategoryTree';
import { Controller } from 'react-hook-form';
import Textarea from '@/admin/components/form/controls/Textarea';

const CategoryFormMainColumn = ({ register, errors, categoryData, params, watch, control }) => {
    return (
        <>
            <Input
                {...register('name', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="name"
                label="Nazwa"
                hasError={!!errors?.name}
                errorMessage={errors?.name?.message}
                isRequired
            />

            <Input
                {...register('slug')}
                type="text"
                id="slug"
                label="Przyjazny url"
                hasError={!!errors?.slug}
                errorMessage={errors?.slug?.message}
            />

            <Controller
                name="description"
                control={control}
                defaultValue=""
                render={({ field }) => <Textarea value={field.value} onChange={field.onChange} title="Opis" />}
            />

          {categoryData.tree && categoryData.tree.length > 0 && (
            <FormCategoryTree
              titleSection="Kategoria nadrzędna"
              hasError={!!errors?.parentCategoryId}
              errorMessage={errors?.parentCategoryId?.message}
              register={register('parentCategoryId')}
              disabledCategoryId={params.id ?? null}
              categories={categoryData.tree || []}
              selected={categoryData.parentCategoryId}
              watch={watch}
              nameWatchedValue="parentCategoryId"
            />
          )}
        </>
    );
};

export default CategoryFormMainColumn;
