import { useState } from 'react';
import CategoryTreeItem from './CategoryTreeItem';

const CategoryTree = ({ categories, selected, watch, disabledCategoryId, register, nameWatchedValue }) => {
    const [openCategories, setOpenCategories] = useState([]);

    const toggleOpen = (id) => {
        setOpenCategories((prev) => (prev.includes(id) ? prev.filter((catId) => catId !== id) : [...prev, id]));
    };

    return (
        <ul>
            {categories.map((category) => (
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
