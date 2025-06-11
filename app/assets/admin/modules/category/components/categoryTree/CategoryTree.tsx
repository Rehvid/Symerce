import { FC, useState } from 'react';
import CategoryTreeItem from './CategoryTreeItem';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';
import { UseFormRegisterReturn, UseFormWatch } from 'react-hook-form';
import { CategoryTreeItemInterface } from '@admin/modules/category/interfaces/CategoryTreeItemInterface';

interface CategoryTreeProps {
    categories: any[];
    selected?: number | null;
    watch: UseFormWatch<CategoryFormData>;
    disabledCategoryId?: number | null;
    register: UseFormRegisterReturn<string>;
    nameWatchedValue: keyof CategoryFormData;
}

const CategoryTree: FC<CategoryTreeProps> = ({ categories, selected, watch, disabledCategoryId, register, nameWatchedValue }) => {
    const [openCategories, setOpenCategories] = useState<(number | string)[]>([]);

    const toggleOpen = (id: number | string) => {
        setOpenCategories((prev) => (prev.includes(id) ? prev.filter((catId) => catId !== id) : [...prev, id]));
    };

    return (
        <ul>
            {categories.map((category: CategoryTreeItemInterface) => (
                <CategoryTreeItem
                    key={category.id}
                    category={category}
                    selected={selected}
                    toggleOpen={toggleOpen}
                    openCategories={openCategories}
                    disabledCategoryId={disabledCategoryId}
                    register={register}
                    watch={watch}
                    nameWatchedValue={nameWatchedValue}
                />
            ))}
        </ul>
    );
};

export default CategoryTree;
