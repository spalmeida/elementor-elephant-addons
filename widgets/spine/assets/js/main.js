("use strict");
(function ($, screen_width = screen.width) {
  $(window).on("elementor/frontend/init", () => {

    function verify_mobile() {
      if (screen_width < 768) {
        return "touchstart";
      }
      return "click";
    }

    loading();

    function loading() {
      if (
        document.querySelectorAll("#chatSpine").length > 0 &&
        document
          .querySelectorAll("#chatSpine")[0]
          .getAttribute("data-spine") !== ""
      ) {
        return loadSpine();
      } else {
        setTimeout(() => {
          return loading();
        }, 1000);
      }
    }

    function loadSpine() {
      const elements = document.getElementById("chatSpine");
      const spineData = JSON.parse(elements.getAttribute("data-spine"));
      /*
      |--------------------------------------------------------------------------
      | Spine Configs
      |--------------------------------------------------------------------------
      */

      /* url */
      const spine_url = spineData.spine_url;
      /* default animation */
      const spine_default_animation = spineData.spine_default_animation;

      /* box sizing */
      const spine_box_width = spineData.spine_box_width;
      const spine_box_height = spineData.spine_box_height;

      /* spine position */
      const spine_position_x = spineData.spine_position_x;
      const spine_position_y = spineData.spine_position_y;

      let spine_scale = 0.1;

      // if (screen_width <= 400) {
      //   spine_scale = 0.08;
      // } else {
      //   spine_scale = spineData.spine_scale;
      // }
      /* spine scale */
      //const spine_scale = spineData.spine_scale;
      //const spine_scale = 0.05;
      console.log(screen_width);
      let animationState = spine_default_animation;

      let siteUrl = spine_url;

      /*
      |--------------------------------------------------------------------------
      | create the pixi app
      |--------------------------------------------------------------------------
      */
      const app = new PIXI.Application({
        backgroundAlpha: 0,
        width: spine_box_width,
        height: spine_box_height,
      });

      document.getElementById("chatSpine").appendChild(app.view);

      /*
      |--------------------------------------------------------------------------
      | load spine data SPINE VERSION 3.8
      |--------------------------------------------------------------------------
      */
      app.loader.add("object_spine", siteUrl).load(onAssetsLoaded);
      app.stage.interactive = true;

      /*
      |--------------------------------------------------------------------------
      | assets loaded, start the animation
      |--------------------------------------------------------------------------
      */

      function onAssetsLoaded(loader, res) {
        const objectSpine = new PIXI.spine.Spine(res.object_spine.spineData);

        // scale and position the spine
        objectSpine.x = app.screen.width / 2;
        objectSpine.y = app.screen.height;
        objectSpine.scale.set(spine_scale);

        // position the professor
        app.stage.position.x = spine_position_x;
        app.stage.position.y = spine_position_y;
        app.stage.addChild(objectSpine);

        // @AnimationsNames ['Clic', 'Clic_idle', 'idle', 'Volta'];
        const loopAnimations = ["idle", "Clic_idle"];

        // default animation started
        //addButtons("0");
        setAnimation(animationState, objectSpine, loopAnimations);

        /*
        |--------------------------------------------------------------------------
        | Animation state change
        |--------------------------------------------------------------------------
        */
        document.querySelector("canvas").addEventListener(verify_mobile(), () => {
          // DISABLE CLICKS
          document.addEventListener(verify_mobile(), disableEvents, true);
          window.navigator.vibrate(200);

          if (animationState == "idle") {
            // STEP 1: idle -> Clic
            animationState = "Clic";
            addButtons("0");
            setAnimation(animationState, objectSpine, loopAnimations);

            // STEP 2: Clic -> Clic_idle
            animationState = "Clic_idle";
            setAnimation(animationState, objectSpine, loopAnimations, "1900");
          } else {
            // STEP 3: Clic_idle -> Volta
            animationState = "Volta";
            setAnimation(animationState, objectSpine, loopAnimations);
            removeButtons("500");

            // STEP 4: Volta -> idle
            animationState = "idle";
            setAnimation(animationState, objectSpine, loopAnimations, "1000");
          }

          // ENABLE CLICKS
          setTimeout(function () {
            document.removeEventListener(verify_mobile(), disableEvents, true);
          }, 2000);
        });
      }

      function setAnimation(animationName, spine, loopAnimations, time = 0) {

        setTimeout(() => {
          spine.state.setAnimation(
            0,
            animationName,
            loopAnimations.includes(animationName)
          );
        }, time);
        //console.log("Animation Name Active: " + animationState);
      }

      function addButtons(time = 700) {
        const buttons = document.getElementById("chat-spine-buttons");
        let list_buttons = document.querySelector(".chat-spine-button");

        list_buttons.classList.remove("animate__fadeOutUp");
        list_buttons.classList.add("animate__fadeInDown");

        setTimeout(() => {
          buttons.style = "display: block;";
        }, time);
      }

      function removeButtons(time = 700) {
        const buttons = document.getElementById("chat-spine-buttons");
        let list_buttons = document.querySelector(".chat-spine-button");

        list_buttons.classList.remove("animate__fadeInDown");
        list_buttons.classList.add("animate__fadeOutUp");

        setTimeout(() => {
          buttons.style = "display: none;";
        }, time);
      }

      // DISABLE CLICKS
      function disableEvents(e) {
        e.stopPropagation();
        e.preventDefault();
      }
    }
  });
})(jQuery);
