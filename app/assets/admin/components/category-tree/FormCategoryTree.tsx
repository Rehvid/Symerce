import Card from '@admin/common/components/Card';
import CategoryTree from '@admin/components/category-tree/CategoryTree';
import Heading from '@admin/common/components/Heading';

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
    isRequired,
}) => {
    return (
        <div>
            <Heading level="h4" additionalClassNames={`mb-2 flex flex-col gap-2 ${hasError ? 'text-red-900' : ''}`}>
                <span className="flex items-center">
                    {titleSection} {isRequired && <span className="pl-1 text-red-500">*</span>}{' '}
                </span>
                {hasError && <p className="text-sm text-red-600">{errorMessage}</p>}
            </Heading>
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
