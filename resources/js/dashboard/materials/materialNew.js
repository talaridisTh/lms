import utilities from '../main';
//! EDITOR INIT
//!============================================================

import ArticleEditor from "../../../plugins/article-editor/article-editor";

$R('#summaryMaterial',{
    minHeight: '150px'
});
$R('#descriptionMaterial',{
    minHeight: '150px'
});
ArticleEditor('#contentMaterial')

//! METHOD INIT
//!============================================================

utilities.changeInputHidden('#urlMaterial','#urlMaterialHiden')
utilities.changeInputHidden('#createAtMaterial','#createAtMaterialHidden')
utilities.changeInputHidden('#coverMaterial','#coverMaterialHidden')
utilities.changeInputHidden('#activeMaterial','#activeMaterialHidden')
utilities.changeInputHidden('#typeMaterial','#typeMaterialHidden')
utilities.changeInputHidden('#instructorMaterial','#instructorMaterialHidden')
utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')
