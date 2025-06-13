import { FC } from 'react';
import { CategoryTreeItemInterface } from '@admin/modules/category/interfaces/CategoryTreeItemInterface';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';
import { UseFormRegisterReturn, UseFormWatch } from 'react-hook-form';

interface CategoryTreeInputProps {
    selected?: number | null;
    category: CategoryTreeItemInterface;
    disabledCategoryId?: number | null;
    register: UseFormRegisterReturn<string>;
    watch: UseFormWatch<CategoryFormData>;
    nameWatchedValue: keyof CategoryFormData;
}

const CategoryTreeInput: FC<CategoryTreeInputProps> = ({
    selected,
    category,
    disabledCategoryId,
    register,
    watch,
    nameWatchedValue,
}) => {
    const isDisabled = disabledCategoryId === category.id;
    return (
        <label
            className={`flex items-center gap-2 ${isDisabled ? '' : 'cursor-pointer'} `}
            htmlFor={`category_${category.id}`}
        >
            <input
                className={`w-5 h-5 ${isDisabled ? '' : 'cursor-pointer'} transition-all duration-500 ease-out transform bg-primary-light text-primary-light
                            ${selected === category.id ? 'scale-110 opacity-100' : 'scale-100 opacity-75'}
                `}
                {...register}
                readOnly={isDisabled}
                id={`category_${category.id}`}
                type="radio"
                disabled={isDisabled}
                value={category.id}
                checked={Number(watch(nameWatchedValue)) === category.id && !isDisabled}
            />
            {category.name}
        </label>
    );
};
export default CategoryTreeInput;
