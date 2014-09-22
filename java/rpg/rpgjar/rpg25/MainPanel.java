import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Rectangle;
import java.awt.Toolkit;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.util.Random;
import java.util.Vector;
import javax.swing.JPanel;

/*
 * Created on 2006/5/5
 *
 */

/**
 * @author mori
 * 
 */
class MainPanel extends JPanel implements KeyListener, Runnable, Common {
    // �p�l���T�C�Y
    public static final int WIDTH = 640;
    public static final int HEIGHT = 640;

    // 1�t���[���̎��ԁi50fps�Ȃ̂�1�t���[��20ms�j
    private static final int PERIOD = 20;

    // �f�o�b�O���[�h�itrue���ƍ��W�Ȃǂ��\�������j
    private static final boolean DEBUG_MODE = true;

    // �}�b�v
    private Map[] maps;
    // ���݂̃}�b�v�ԍ�
    private int mapNo;

    // �E��
    private Chara hero;

    // �A�N�V�����L�[
    private ActionKey leftKey;
    private ActionKey rightKey;
    private ActionKey upKey;
    private ActionKey downKey;
    private ActionKey spaceKey;

    // �Q�[�����[�v
    private Thread gameLoop;

    // ����������
    private Random rand = new Random();

    // �E�B���h�E
    private MessageWindow messageWindow;
    // �E�B���h�E��\������̈�
    private static Rectangle WND_RECT = new Rectangle(142, 480, 356, 140);

    // �T�E���h�G���W��
    private MidiEngine midiEngine = new MidiEngine();
    private WaveEngine waveEngine = new WaveEngine();

    // BGM���ifrom TAM Music Factory: http://www.tam-music.com/�j
    private static final String[] bgmNames = {"castle", "field"};
    private static final String[] bgmFiles = {"bgm/castle.mid",
            "bgm/field.mid"};

    // �T�E���h��
    private static final String[] soundNames = {"treasure", "door", "step"};
    private static final String[] soundFiles = {"sound/treasure.wav",
            "sound/door.wav", "sound/step.wav"};

    // �_�u���o�b�t�@�����O�p
    private Graphics dbg;
    private Image dbImage = null;

    public MainPanel() {
        // �p�l���̐����T�C�Y��ݒ�
        setPreferredSize(new Dimension(WIDTH, HEIGHT));

        // �p�l�����L�[������󂯕t����悤�ɓo�^����
        setFocusable(true);
        addKeyListener(this);

        // �A�N�V�����L�[���쐬
        leftKey = new ActionKey();
        rightKey = new ActionKey();
        upKey = new ActionKey();
        downKey = new ActionKey();
        spaceKey = new ActionKey(ActionKey.DETECT_INITIAL_PRESS_ONLY);

        // �}�b�v���쐬�i�}�b�v�Ŗ炷BGM�ԍ���n���j
        maps = new Map[2];
        // ����
        maps[0] = new Map("map/castle.map", "map/castle.evt", "castle", this);
        maps[1] = new Map("map/field.map", "map/field.evt", "field", this);
        // �ŏ��͂���
        mapNo = 0;

        // �E�҂��쐬
        hero = new Chara(6, 6, 0, DOWN, 0, maps[mapNo]);

        // �}�b�v�ɃL�����N�^�[��o�^
        // �L�����N�^�[�̓}�b�v�ɑ���
        maps[mapNo].addChara(hero);

        // �E�B���h�E��ǉ�
        messageWindow = new MessageWindow(WND_RECT);

        // �T�E���h�����[�h
        loadSound();

        // �}�b�v�Ɋ��蓖�Ă�ꂽBGM���Đ�
        midiEngine.play(maps[mapNo].getBgmName());

        // �Q�[�����[�v�J�n
        gameLoop = new Thread(this);
        gameLoop.start();
    }

    public void run() {
        long beforeTime, timeDiff, sleepTime;

        beforeTime = System.currentTimeMillis();

        while (true) {
            // �L�[���͂��`�F�b�N
            checkInput();
            // �Q�[����Ԃ��X�V
            gameUpdate();
            // �����_�����O
            gameRender();
            // ��ʂɕ`��
            paintScreen();

            timeDiff = System.currentTimeMillis() - beforeTime;
            sleepTime = PERIOD - timeDiff; // ���̃t���[���̎c�莞��

            // �Œ�ł�5ms�͋x�~������
            if (sleepTime <= 0) {
                sleepTime = 5;
            }

            try {
                Thread.sleep(sleepTime);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }

            beforeTime = System.currentTimeMillis();
        }
    }

    /**
     * �L�[���͂��`�F�b�N����
     */
    private void checkInput() {
        if (messageWindow.isVisible()) { // ���b�Z�[�W�E�B���h�E�\����
            messageWindowCheckInput();
        } else { // ���C�����
            mainWindowCheckInput();
        }
    }

    /**
     * �Q�[����Ԃ��X�V����
     */
    private void gameUpdate() {
        if (!messageWindow.isVisible()) {
            // �E�҂̈ړ�����
            heroMove();
            // �L�����N�^�[�̈ړ�����
            charaMove();
        }
    }

    /**
     * �o�b�t�@�Ƀ����_�����O
     */
    private void gameRender() {
        // ����̌Ăяo�����Ƀ_�u���o�b�t�@�����O�p�I�u�W�F�N�g���쐬
        if (dbImage == null) {
            // �o�b�t�@�C���[�W
            dbImage = createImage(WIDTH, HEIGHT);
            if (dbImage == null) {
                return;
            } else {
                // �o�b�t�@�C���[�W�̕`��I�u�W�F�N�g
                dbg = dbImage.getGraphics();
            }
        }

        // �o�b�t�@���N���A
        dbg.setColor(Color.WHITE);
        dbg.fillRect(0, 0, WIDTH, HEIGHT);

        // X�����̃I�t�Z�b�g���v�Z
        int offsetX = MainPanel.WIDTH / 2 - hero.getPx();
        // �}�b�v�̒[�ł̓X�N���[�����Ȃ��悤�ɂ���
        offsetX = Math.min(offsetX, 0);
        offsetX = Math.max(offsetX, MainPanel.WIDTH - maps[mapNo].getWidth());

        // Y�����̃I�t�Z�b�g���v�Z
        int offsetY = MainPanel.HEIGHT / 2 - hero.getPy();
        // �}�b�v�̒[�ł̓X�N���[�����Ȃ��悤�ɂ���
        offsetY = Math.min(offsetY, 0);
        offsetY = Math.max(offsetY, MainPanel.HEIGHT - maps[mapNo].getHeight());

        // �}�b�v��`��
        // �L�����N�^�[�̓}�b�v���`���Ă����
        maps[mapNo].draw(dbg, offsetX, offsetY);

        // ���b�Z�[�W�E�B���h�E��`��
        messageWindow.draw(dbg);

        // �f�o�b�O���̕\��
        if (DEBUG_MODE) {
            Font font = new Font("SansSerif", Font.BOLD, 16);
            dbg.setFont(font);
            dbg.setColor(Color.YELLOW);
            dbg.drawString(maps[mapNo].getMapName() + " (" + maps[mapNo].getCol() + "," + maps[mapNo].getRow() + ")", 4, 16);
            dbg.drawString("(" + hero.getX() + "," + hero.getY() + ") ", 4, 32);
            dbg.drawString("(" + hero.getPx() + "," + hero.getPy() + ")", 4, 48);
            dbg.drawString(maps[mapNo].getBgmName(), 4, 64);
        }
    }

    /**
     * �o�b�t�@����ʂɕ`��
     * 
     */
    private void paintScreen() {
        Graphics g = getGraphics();
        // �o�b�t�@�C���[�W����ʂɕ`��
        if ((g != null) && (dbImage != null)) {
            g.drawImage(dbImage, 0, 0, null);
        }
        Toolkit.getDefaultToolkit().sync();
        if (g != null) {
            g.dispose();
        }
    }

    /**
     * ���C���E�B���h�E�ł̃L�[���͂��`�F�b�N����
     */
    private void mainWindowCheckInput() {
        if (leftKey.isPressed()) { // ��
            if (!hero.isMoving()) { // �ړ����łȂ����
                hero.setDirection(LEFT); // �������Z�b�g����
                hero.setMoving(true); // �ړ��i�X�N���[���j�J�n
            }
        }
        if (rightKey.isPressed()) { // �E
            if (!hero.isMoving()) {
                hero.setDirection(RIGHT);
                hero.setMoving(true);
            }
        }
        if (upKey.isPressed()) { // ��
            if (!hero.isMoving()) {
                hero.setDirection(UP);
                hero.setMoving(true);
            }
        }
        if (downKey.isPressed()) { // ��
            if (!hero.isMoving()) {
                hero.setDirection(DOWN);
                hero.setMoving(true);
            }
        }
        if (spaceKey.isPressed()) { // �X�y�[�X
            // �ړ����͕\���ł��Ȃ�
            if (hero.isMoving())
                return;

            // ����ׂ�
            TreasureEvent treasure = hero.search();
            if (treasure != null) {
                // ������
                waveEngine.play("treasure");
                // ���b�Z�[�W���Z�b�g����
                messageWindow.setMessage(treasure.getItemName() + "���@�Ăɂ��ꂽ�B");
                // ���b�Z�[�W�E�B���h�E��\��
                messageWindow.show();
                // TODO: �����ɃA�C�e�����菈��������
                // �󔠂��폜
                maps[mapNo].removeEvent(treasure);
                return; // ����ׂ��ꍇ�͂͂Ȃ��Ȃ�
            }

            // �Ƃт�
            DoorEvent door = hero.open();
            if (door != null) {
                // ���[
                waveEngine.play("door");
                // �h�A���폜
                maps[mapNo].removeEvent(door);

                return;
            }

            // �͂Ȃ�
            if (!messageWindow.isVisible()) { // ���b�Z�[�W�E�B���h�E��\��
                Chara chara = hero.talkWith();
                if (chara != null) {
                    // ���b�Z�[�W���Z�b�g����
                    messageWindow.setMessage(chara.getMessage());
                    // ���b�Z�[�W�E�B���h�E��\��
                    messageWindow.show();
                } else {
                    messageWindow.setMessage("���̂ق������ɂ́@��������Ȃ��B");
                    messageWindow.show();
                }
            }
        }
    }

    /**
     * ���b�Z�[�W�E�B���h�E�ł̃L�[���͂��`�F�b�N����
     */
    private void messageWindowCheckInput() {
        if (spaceKey.isPressed()) {
            if (messageWindow.nextMessage()) { // ���̃��b�Z�[�W��
                messageWindow.hide(); // �I��������B��
            }
        }
    }

    /**
     * �E�҂̈ړ�����
     */
    private void heroMove() {
        // �ړ��i�X�N���[���j���Ȃ�ړ�����
        if (hero.isMoving()) {
            if (hero.move()) { // �ړ��i�X�N���[���j
                // �ړ�������������̏����͂����ɏ���

                // �ړ��C�x���g
                // �C�x���g�����邩�`�F�b�N
                Event event = maps[mapNo].eventCheck(hero.getX(), hero.getY());
                if (event instanceof MoveEvent) { // �ړ��C�x���g�Ȃ�
                    MoveEvent m = (MoveEvent) event;
                    // ������������
                    waveEngine.play("step");
                    // �ړ����}�b�v�̗E�҂�����
                    maps[mapNo].removeChara(hero);
                    // ���݂̃}�b�v�ԍ��Ɉړ���̃}�b�v�ԍ���ݒ�
                    mapNo = m.destMapNo;
                    // �ړ���}�b�v�ł̍��W���擾���ėE�҂���蒼��
                    hero = new Chara(m.destX, m.destY, 0, DOWN, 0, maps[mapNo]);
                    // �ړ���}�b�v�ɗE�҂�o�^
                    maps[mapNo].addChara(hero);
                    // �ړ���}�b�v��BGM��炷
                    midiEngine.play(maps[mapNo].getBgmName());
                }
            }
        }
    }

    /**
     * �E�҈ȊO�̃L�����N�^�[�̈ړ�����
     */
    private void charaMove() {
        // �}�b�v�ɂ���L�����N�^�[���擾
        Vector charas = maps[mapNo].getCharas();
        for (int i = 0; i < charas.size(); i++) {
            Chara chara = (Chara) charas.get(i);
            // �L�����N�^�[�̈ړ��^�C�v�𒲂ׂ�
            if (chara.getMoveType() == 1) { // �ړ�����^�C�v�Ȃ�
                if (chara.isMoving()) { // �ړ����Ȃ�
                    chara.move(); // �ړ�����
                } else if (rand.nextDouble() < Chara.PROB_MOVE) {
                    // �ړ����ĂȂ��ꍇ��Chara.PROB_MOVE�̊m���ōĈړ�����
                    // �����̓����_���Ɍ��߂�
                    chara.setDirection(rand.nextInt(4));
                    chara.setMoving(true);
                }
            }
        }
    }

    /**
     * �L�[�������ꂽ��L�[�̏�Ԃ��u�����ꂽ�v�ɕς���
     * 
     * @param e �L�[�C�x���g
     */
    public void keyPressed(KeyEvent e) {
        int keyCode = e.getKeyCode();

        if (keyCode == KeyEvent.VK_LEFT) {
            leftKey.press();
        }
        if (keyCode == KeyEvent.VK_RIGHT) {
            rightKey.press();
        }
        if (keyCode == KeyEvent.VK_UP) {
            upKey.press();
        }
        if (keyCode == KeyEvent.VK_DOWN) {
            downKey.press();
        }
        if (keyCode == KeyEvent.VK_SPACE) {
            spaceKey.press();
        }
    }

    /**
     * �L�[�������ꂽ��L�[�̏�Ԃ��u�����ꂽ�v�ɕς���
     * 
     * @param e �L�[�C�x���g
     */
    public void keyReleased(KeyEvent e) {
        int keyCode = e.getKeyCode();

        if (keyCode == KeyEvent.VK_LEFT) {
            leftKey.release();
        }
        if (keyCode == KeyEvent.VK_RIGHT) {
            rightKey.release();
        }
        if (keyCode == KeyEvent.VK_UP) {
            upKey.release();
        }
        if (keyCode == KeyEvent.VK_DOWN) {
            downKey.release();
        }
        if (keyCode == KeyEvent.VK_SPACE) {
            spaceKey.release();
        }
    }

    public void keyTyped(KeyEvent e) {
    }

    /**
     * �T�E���h�����[�h����
     */
    private void loadSound() {
        // BGM�����[�h
        for (int i = 0; i < bgmNames.length; i++) {
            midiEngine.load(bgmNames[i], bgmFiles[i]);
        }

        // �T�E���h�����[�h
        for (int i = 0; i < soundNames.length; i++) {
            waveEngine.load(soundNames[i], soundFiles[i]);
        }
    }
}
