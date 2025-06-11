import Card from '@admin/common/components/Card';
import CategoryTree from '@admin/modules/category/components/categoryTree/CategoryTree';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import { FC } from 'react';
import { CategoryTreeItemInterface } from '@admin/modules/category/interfaces/CategoryTreeItemInterface';
import { UseFormRegisterReturn, UseFormWatch } from 'react-hook-form';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';

interface FormCategoryTreeProps {
    categories: CategoryTreeItemInterface[];
    selected?: number | null;
    register: UseFormRegisterReturn<string>;
    disabledCategoryId?: number | null;
    hasError: boolean;
    errorMessage?: string;
    watch: UseFormWatch<CategoryFormData>;
    nameWatchedValue: keyof CategoryFormData;
    isRequired?: boolean;
}

const FormCategoryTree: FC<FormCategoryTreeProps> = ({
    categories,
    selected,
    register,
    disabledCategoryId,
    hasError,
    errorMessage,
    watch,
    nameWatchedValue,
    isRequired,
}) => {
    return (
        <div>
            <Heading
                level={HeadingLevel.H3}
                additionalClassNames={`mb-2 flex flex-col gap-2 ${hasError ? 'text-red-900' : ''}`}
            >
                <span className="flex items-center">
                    {isRequired && <span className="pl-1 text-red-500">*</span>}{' '}
                </span>
                {hasError && <p className="text-sm text-red-600">{errorMessage}</p>}
            </Heading>
            <Card additionalClasses={`overflow-auto border border-gray-100 ${hasError ? 'border-red-500' : ''}`}>
                <CategoryTree
                    categories={categories || []}
                    selected={selected}
                    register={register}
                    disabledCategoryId={Number(disabledCategoryId)}
                    watch={watch}
                    nameWatchedValue={nameWatchedValue}
                />
            </Card>
        </div>
    );
};

export default FormCategoryTree;
