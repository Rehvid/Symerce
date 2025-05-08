import ChevronIcon from '@/images/icons/chevron.svg';
import CategoryTreeInput from '@/admin/components/category-tree/CategoryTreeInput';

const CategoryTreeItem = ({
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
                        className={`${isOpen ? '-rotate-90' : 'rotate-0'} transition-transform duration-300 text-gray-500 scale-[90%] cursor-pointer`}
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
