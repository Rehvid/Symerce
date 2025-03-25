import ChevronIcon from "../../../images/shared/chevron.svg";

function CategoryTreeItem ({ category, selected, setSelected, toggleOpen, openCategories, disabledCategoryId }){
    const isOpen = openCategories.includes(category.id);

    const canOpen = isOpen && category.children.length > 0;

    return (
        <li className="pl-4">
            <div className={`flex  mb-3 ${category.children.length <= 0 ? 'pl-[24px]' : ''} `}>
                {category.children.length > 0 && (
                  <ChevronIcon
                      onClick={() => toggleOpen(category.id)}
                      className={`${isOpen ? '-rotate-90' : 'rotate-0'} transition-transform duration-300 text-gray-500 scale-[90%] cursor-pointer`}
                  />
                )}
                <label className={`flex items-center gap-2 `} htmlFor={`category_${category.id}`}>
                    <input
                        className={`w-5 h-5 transition-all duration-500 ease-out transform bg-primary-light text-primary-light
                            ${selected === category.id ? "scale-110 opacity-100" : "scale-100 opacity-75"}
                        `}
                        id={`category_${category.id}`}
                        type="radio"
                        name="category"
                        value={category.id}
                        checked={selected === category.id}
                        onChange={() => setSelected(category.id)}
                        disabled={disabledCategoryId === category.id}
                    />
                    {category.name}
                </label>
            </div>

            {category.children.length > 0 && isOpen && (
                <ul className="pl-5">
                    {category.children.map((child) => (
                        <CategoryTreeItem
                            key={child.id}
                            category={child}
                            selected={selected}
                            setSelected={setSelected}
                            toggleOpen={toggleOpen}
                            openCategories={openCategories}
                            disabledCategoryId={disabledCategoryId}
                        />
                    ))}
                </ul>
            )}
        </li>
    );
}

export default CategoryTreeItem;
