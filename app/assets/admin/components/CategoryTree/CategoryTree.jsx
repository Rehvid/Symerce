import { useState } from 'react';
import CategoryTreeItem from './CategoryTreeItem';

const CategoryTree = ({ categories, selected, setSelected, disabledCategoryId }) => {
    const [openCategories, setOpenCategories] = useState([]);

    const toggleOpen = id => {
        setOpenCategories(prev => (prev.includes(id) ? prev.filter(catId => catId !== id) : [...prev, id]));
    };

    return (
        <ul>
            {categories.map(category => (
                <CategoryTreeItem
                    key={category.id}
                    category={category}
                    selected={selected}
                    setSelected={setSelected}
                    toggleOpen={toggleOpen}
                    openCategories={openCategories}
                    disabledCategoryId={disabledCategoryId}
                />
            ))}
        </ul>
    );
};

export default CategoryTree;
