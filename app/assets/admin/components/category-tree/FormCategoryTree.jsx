import Card from '@/admin/components/Card';
import CategoryTree from '@/admin/components/category-tree/CategoryTree';
import React from 'react';

const FormCategoryTree = ({
    categories,
    selected,
    register,
    disabledCategoryId,
    titleSection,
    hasError,
    errorMessage,
    watch,
    nameWatchedValue,
    isRequired
}) => {
    return (
        <div>
            <h1 className={`mb-2 flex flex-col gap-2 ${hasError ? 'text-red-900' : 'text-gray-500'}`}>
                <span className="flex items-center">{titleSection} {isRequired && <span className="pl-1 text-red-500">*</span>} </span>
                {hasError && <p className="text-sm text-red-600">{errorMessage}</p>}
            </h1>
            <Card additionalClasses={`overflow-auto ${hasError ? 'border-red-500' : ''}`}>
                <CategoryTree
                    categories={categories || []}
                    selected={selected}
                    register={register}
                    disabledCategoryId={Number(disabledCategoryId)}
                    watch={watch}
                    nameWatchedValue={nameWatchedValue}
                    isRequired={isRequired}
                />
            </Card>
        </div>
    );
};

export default FormCategoryTree;
