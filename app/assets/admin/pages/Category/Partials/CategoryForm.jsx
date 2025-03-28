import AppButton from "../../../components/Common/AppButton";
import React, {useEffect} from "react";
import {useForm} from "react-hook-form";
import CategoryFormSideBar from "./CategoryFormSideBar";
import CategoryFormMainDetails from "./CategoryFormMainDetails";

const CategoryForm = ({onSubmit, categoryData, setSelectedCategory, selectedCategory }) => {
    const {
        register,
        handleSubmit,
        setValue,
        formState: {errors}
    } = useForm();

    useEffect(() => {
        if (categoryData) {
            setValue("name", categoryData.name);
            setValue("description", categoryData.description);
            setValue("isActive", categoryData.isActive);
            setSelectedCategory(categoryData.parentCategoryId);
        }
    }, [categoryData]);

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <div className="flex flex-row gap-4 mt-5">
                <div className="flex flex-col w-full gap-4">
                    <CategoryFormMainDetails
                        register={register}
                        errors={errors}
                        setValue={setValue}
                        categoryData={categoryData}
                        setSelectedCategory={setSelectedCategory}
                        selectedCategory={selectedCategory}
                    />
                </div>
                <CategoryFormSideBar register={register} />
            </div>
            <div className="sticky bottom-0 left-0 right-0 z-10 mt-8 bg-white  p-4 flex justify-end">
                <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2" >Zapisz </AppButton>
            </div>
        </form>
    );
}

export default CategoryForm;
