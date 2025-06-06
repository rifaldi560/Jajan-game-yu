gdjs.Untitled_32scene3Code = {};
gdjs.Untitled_32scene3Code.localVariables = [];
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1= [];
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects2= [];
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects1= [];
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects2= [];
gdjs.Untitled_32scene3Code.GDwinObjects1= [];
gdjs.Untitled_32scene3Code.GDwinObjects2= [];
gdjs.Untitled_32scene3Code.GDtextObjects1= [];
gdjs.Untitled_32scene3Code.GDtextObjects2= [];


gdjs.Untitled_32scene3Code.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("WhiteSquareDecoratedButton"), gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1.length;i<l;++i) {
    if ( gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1[i].IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1[k] = gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1[i];
        ++k;
    }
}
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "FullSokobanGame", false);
}}

}


};

gdjs.Untitled_32scene3Code.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDwinObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDwinObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDtextObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDtextObjects2.length = 0;

gdjs.Untitled_32scene3Code.eventsList0(runtimeScene);
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDWhiteSquareDecoratedButtonObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDPortraitBackroundObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDwinObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDwinObjects2.length = 0;
gdjs.Untitled_32scene3Code.GDtextObjects1.length = 0;
gdjs.Untitled_32scene3Code.GDtextObjects2.length = 0;


return;

}

gdjs['Untitled_32scene3Code'] = gdjs.Untitled_32scene3Code;
