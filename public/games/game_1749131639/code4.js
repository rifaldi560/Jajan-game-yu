gdjs.Untitled_32sceneCode = {};
gdjs.Untitled_32sceneCode.localVariables = [];
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1= [];
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects2= [];
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects1= [];
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects2= [];
gdjs.Untitled_32sceneCode.GDwinObjects1= [];
gdjs.Untitled_32sceneCode.GDwinObjects2= [];
gdjs.Untitled_32sceneCode.GDtextObjects1= [];
gdjs.Untitled_32sceneCode.GDtextObjects2= [];


gdjs.Untitled_32sceneCode.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("WhiteSquareDecoratedButton"), gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1.length;i<l;++i) {
    if ( gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1[i].IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1[k] = gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1[i];
        ++k;
    }
}
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "FullSokobanGame2", false);
}}

}


};

gdjs.Untitled_32sceneCode.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDwinObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDwinObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDtextObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDtextObjects2.length = 0;

gdjs.Untitled_32sceneCode.eventsList0(runtimeScene);
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDWhiteSquareDecoratedButtonObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDPortraitBackroundObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDwinObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDwinObjects2.length = 0;
gdjs.Untitled_32sceneCode.GDtextObjects1.length = 0;
gdjs.Untitled_32sceneCode.GDtextObjects2.length = 0;


return;

}

gdjs['Untitled_32sceneCode'] = gdjs.Untitled_32sceneCode;
