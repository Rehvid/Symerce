import ChevronIcon from '@/images/icons/chevron.svg';
import CategoryTreeInput from '@admin/modules/category/components/categoryTree/CategoryTreeInput';
import React from 'react';
import { CategoryTreeItemInterface } from '@admin/modules/category/interfaces/CategoryTreeItemInterface';
import { UseFormRegisterReturn, UseFormWatch } from 'react-hook-form';
import { CategoryFormData } from '@admin/modules/category/interfaces/CategoryFormData';

interface CategoryTreeItemProps {
    category: CategoryTreeItemInterface;
    selected?: number | null;
    disabledCategoryId?: number | null;
    register: UseFormRegisterReturn<string>;
    watch: UseFormWatch<CategoryFormData>;
    nameWatchedValue: keyof CategoryFormData;
    toggleOpen: (id: number | string) => void;
    openCategories: (number | string)[];
}

const CategoryTreeItem: React.FC<CategoryTreeItemProps> = ({
    category,
    selected,
    toggleOpen,
    openCategories,
    disabledCategoryId,
    register,
    watch,
    nameWatchedValue,
}) => {
    const isOpen = openCategories.includes(category.id);

    return (
        <li className="pl-4">
            <div className={`flex mb-3 ${category.children.length >= 0 ? 'pl-[24px]' : ''} `}>
                {category.children.length > 0 && (
                    <ChevronIcon
                        onClick={() => toggleOpen(category.id)}
                        className={`${isOpen ? '-rotate-90' : 'rotate-0'} transition-transform duration-300 text-gray-500 w-[24px] h-[24px] cursor-pointer`}
                    />
                )}
                <CategoryTreeInput
                    category={category}
                    selected={selected}
                    disabledCategoryId={disabledCategoryId}
                    key={`category_${category.id}`}
                    register={register}
                    watch={watch}
                    nameWatchedValue={nameWatchedValue}
                />
            </div>

            {category.children.length > 0 && isOpen && (
                <ul className="pl-5">
                    {category.children.map((child) => (
                        <CategoryTreeItem
                            key={child.id}
                            category={child}
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
            )}
        </li>
    );
};

export default CategoryTreeItem;
