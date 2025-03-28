import AppInput from '../../../../shared/components/Form/AppInput';
import Card from '../../../components/Card';
import CategoryTree from '../../../components/CategoryTree/CategoryTree';
import React from 'react';

const CategoryFormMainDetails = ({
    register,
    errors,
    setValue,
    categoryData,
    selectedCategory,
    setSelectedCategory,
}) => {
    return (
        <Card>
            <h3 className="text-lg font-semibold">Basic information</h3>
            <div className="flex flex-col gap-4 mt-5">
                <AppInput
                    {...register('name', {
                        required: 'Pole nazwa jest wymagana',
                        minLength: {
                            value: 3,
                            message: 'Nazwa musi mieć co najmniej 3 znaki',
                        },
                    })}
                    type="text"
                    id="name"
                    label="Nazwa"
                    hasError={errors.hasOwnProperty('name')}
                    errorMessage={errors?.name?.message}
                />
                <AppInput
                    {...register('description')}
                    type="text"
                    id="description"
                    label="Opis"
                    hasError={errors.hasOwnProperty('description')}
                    errorMessage={errors?.description?.message}
                />

                <div>
                    <h1>Parent category</h1>
                    <Card additionalClasses="overflow-auto">
                        <CategoryTree
                            categories={categoryData.tree || []}
                            selected={selectedCategory}
                            setSelected={setSelectedCategory}
                            register={register}
                            setValue={setValue}
                            disabledCategoryId={categoryData.parentCategoryId ?? null}
                        />
                    </Card>
                </div>
            </div>
        </Card>
    );
};

export default CategoryFormMainDetails;
